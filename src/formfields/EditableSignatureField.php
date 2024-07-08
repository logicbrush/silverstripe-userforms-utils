<?php

namespace Logicbrush\UserFormsUtils\FormFields;

use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\UserForms\Model\EditableFormField;

class EditableSignatureField extends EditableFormField {

    private static $singular_name = 'Signature Field';
    private static $plural_name = 'Signature Fields';
    private static $table_name = 'EditableSignatureField';

    public function getFormField() {
        $field = TextField::create($this->Name, $this->Title ?: false)
            ->setTemplate(EditableSignatureField::class);
        $this->doUpdateFormField($field);
        return $field;
    }


}
