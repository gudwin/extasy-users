<?php


namespace Extasy\Login\tests\Columns;


use Extasy\Users\Columns\ConfirmationCode;
use Extasy\Users\tests\BaseTest;

class ConfirmationCodeTest extends BaseTest
{
    public function testGenerateValue() {
        $column = new ConfirmationCode('test',[],null);
        $this->assertEmpty( $column->getValue() );
        $column->generate();
        $this->assertNotEmpty( $column->getValue() );
    }
}