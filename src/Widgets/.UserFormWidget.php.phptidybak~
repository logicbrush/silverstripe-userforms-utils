<?php

namespace Logicbrush\UserFormsUtils\Widgets;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\Widgets\Model\Widget;

if (!class_exists(Widget::class)) {
    return;
}

class UserFormWidget extends Widget
{
    private static $title = 'User Form Widget';
    private static $cmsTitle = 'User Form Widget';
    private static $description = 'Include a user form defined elsewhere in your sidebar.';
    private static $table_name = 'UserFormWidget';

    private static $db = [
        'IntroText' => 'Text',
        'ShowFormTitle' => 'Boolean',
        'ShowFormContent' => 'Boolean',
    ];

    private static $has_one = [
        'UserForm' => UserDefinedForm::class,
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create();
        $fields->push(TextareaField::create('IntroText', 'Introductory text'));
        $fields->push(
            DropdownField::create(
                'UserFormID',
                'Select a form',
                UserDefinedForm::get()->map('ID', 'Title')
            )->setEmptyString('')
        );
        $fields->push(CheckboxField::create('ShowFormTitle', 'Show form title?'));
        $fields->push(CheckboxField::create('ShowFormContent', 'Show form content?'));

        return $fields;
    }
}
