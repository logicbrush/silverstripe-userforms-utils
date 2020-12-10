<?php

namespace Logicbrush\UserFormsUtils\Controllers;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableFormStep;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\Widgets\Model\WidgetController;

if (!class_exists(WidgetController::class)) {
    return;
}

class UserFormWidgetController extends WidgetController
{
    public function Showing()
    {
        return ($userDefinedForm = $this->UserForm()) && $userDefinedForm->ID != Controller::curr()->ID;
    }

    public function FormContent()
    {
        if ($this->UserForm()->exists() && $this->UserForm()->Content) {
            return DBField::create_field(
                'HTMLText',
                preg_replace(
                    '/(<p[^>]*>)?\\$UserDefinedForm(<\\/p>)?/i',
                    '',
                    $this->UserForm()->Content
                )
            );
        }

        return false;
    }

    public function UserDefinedForm()
    {
        $userDefinedForm = $this->UserForm();

        if (!$userDefinedForm || !$userDefinedForm->exists()) {
            return null;
        }

        $required = RequiredFields::create();

        $fields = FieldList::create();
        $userDefinedFormFields = EditableFormField::get()->filter(['ParentID' => $userDefinedForm->ID]);
        $formStepsCount = $userDefinedFormFields->filter(['ClassName' => EditableFormStep::class])->Count();

        foreach ($userDefinedFormFields as $field) {
            if ($field instanceof EditableFormStep) {
                if ($formStepsCount > 1) {
                    $stepField = $field->getFormField();
                    if ($stepField->title) {
                        $headerField = HeaderField::create(
                            $stepField->name,
                            $stepField->title,
                            3
                        );
                        $fields->push($headerField);
                    }
                }
            } else {
                $fields->push($ff = $field->getFormField());
                if ($field->Required) {
                    $required->addRequiredField($ff->Name);
                    $ff->addExtraClass('requiredField');
                }
            }
        }

        $actions = FieldList::create();
        $actions->push(
            FormAction::create(
                'process',
                ($userDefinedForm->SubmitButtonText) ? $userDefinedForm->SubmitButtonText : _t('UserDefinedForm.SUBMITBUTTON', 'Submit')
            )
        );

        $form = Form::create($this, UserDefinedForm::class, $fields, $actions, $required);
        $form->setFormAction($this->UserForm()->Link('Form') . '?BackURL=' . urlencode($this->UserForm()->Link() . '#Form_Form'));

        return $form;
    }
}
