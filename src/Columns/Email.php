<?php
namespace Extasy\Users\Columns;

use \Extasy\Model\Columns\Input;
use \Faid\View\View;

class Email extends Input
{
    public function getAdminFormValue()
    {
        $view = new View(__DIR__ . '/email.tpl');
        $view->set('name', $this->fieldName);
        $view->set('value', $this->value);

        return $view->render();
    }
} 