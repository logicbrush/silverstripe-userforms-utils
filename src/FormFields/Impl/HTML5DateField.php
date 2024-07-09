<?php

namespace Logicbrush\UserFormsUtils\FormFields\Impl;

use SilverStripe\Forms\DateField;

class HTML5DateField extends DateField {

    public function __construct($name, $title = null, $value = "")
    {
        parent::__construct($name, $title, $value);
        $this->setHTML5(true);
    }


    public function getAttributes()
    {
        return array_merge(
            parent::getAttributes(),
            array(
                'type' => 'date'
            )
        );
    }

}
