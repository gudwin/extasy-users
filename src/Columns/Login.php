<?php
namespace Extasy\Users\Columns;

use \Extasy\Model\Columns\Input;

class Login extends Input {
	public function setValue( $newValue ){
		if ( empty( $newValue )) {
			throw new \InvalidArgumentException('Login can`t be empty');
		}
		parent::setValue( $newValue );
	}
}