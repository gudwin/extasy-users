<?php

namespace Extasy\Users\Columns;

use \Faid\View\View;
use Extasy\Model\Columns\Input;

class ConfirmationCode extends Input
{
    public function getAdminFormValue()
    {
        $view = new View(__DIR__ . '/confirmation_code.tpl');
        $view->set('name', $this->fieldName);
        $view->set('value', $this->value);

        return $view->render();
    }
} 