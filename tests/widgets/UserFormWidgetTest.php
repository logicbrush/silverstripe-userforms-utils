<?php

namespace Logicbrush\UserFormsUtils\Tests\Widgets;

use Logicbrush\UserFormsUtils\Controllers\UserFormWidgetController;
use Logicbrush\UserFormsUtils\Widgets\UserFormWidget;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\Form;
use SilverStripe\UserForms\Model\EditableFormField\EditableFormStep;
use SilverStripe\UserForms\Model\EditableFormField\EditableTextField;
use SilverStripe\UserForms\Model\UserDefinedForm;

class UserFormWidgetTest extends FunctionalTest
{
    protected $usesDatabase = true;

    public function testCreateUserFormWidget()
    {
        $userFormWidget = new UserFormWidget();
        $userFormWidget->write();

        $this->assertNotNull($userFormWidget);
    }

    public function testShowing()
    {
        $userDefinedForm = new UserDefinedForm();
        $userDefinedForm->Title = 'User Defined Form';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();

        $userFormWidget = new UserFormWidget();
        $userFormWidget->write();

        $userFormWidgetController = new UserFormWidgetController($userFormWidget);

        $this->assertFalse($userFormWidgetController->Showing());

        $userFormWidget->UserFormID = $userDefinedForm->ID;
        $userFormWidget->write();

        $this->assertTrue($userFormWidgetController->Showing());
    }

    public function testFormContent()
    {
        $userDefinedForm = new UserDefinedForm();
        $userDefinedForm->Title = 'User Defined Form';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();

        $userFormWidget = new UserFormWidget();
        $userFormWidget->write();

        $userFormWidgetController = new UserFormWidgetController($userFormWidget);

        $this->assertFalse($userFormWidgetController->FormContent());

        $userFormWidget->UserFormID = $userDefinedForm->ID;
        $userFormWidget->write();

        $this->assertEquals('', $userFormWidgetController->FormContent()->getValue());

        $userDefinedForm->Content = '';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();
        $userFormWidget->write();

        $this->assertFalse($userFormWidgetController->FormContent());

        $userDefinedForm->Content = '<p>User Defined Form</p>';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();
        $userFormWidget->write();

        $formContent = $userFormWidgetController->FormContent()->getValue();

        $this->assertContains('<p>User Defined Form</p>', $formContent);
    }

    public function testUserDefinedForm()
    {
        $userDefinedForm = new UserDefinedForm();
        $userDefinedForm->Title = 'User Defined Form';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();

        $textField = new EditableTextField();
        $textField->Name = 'text-field';
        $textField->Title = 'Text field';
        $textField->write();
        $textField->publishRecursive();

        $userDefinedForm->Fields()->add($textField);

        $userFormWidget = new UserFormWidget();
        $userFormWidget->write();

        $userFormWidgetController = new UserFormWidgetController($userFormWidget);

        $this->assertNull($userFormWidgetController->UserDefinedForm());

        $userFormWidget->UserFormID = $userDefinedForm->ID;
        $userFormWidget->write();

        $form = $userFormWidgetController->UserDefinedForm();

        $this->assertNotNull($form);
        $this->assertEquals(Form::class, get_class($form));
        $this->assertEquals(1, $form->Fields()->count());

        $formStep1 = new EditableFormStep();
        $formStep1->Name = 'form-step-1';
        $formStep1->Title = 'Form step 1';
        $formStep1->write();
        $formStep1->publishRecursive();

        $textField2 = new EditableTextField();
        $textField2->Name = 'text-field-2';
        $textField2->Title = 'Text field 2';
        $textField2->write();
        $textField2->publishRecursive();

        $formStep2 = new EditableFormStep();
        $formStep2->Name = 'form-step-2';
        $formStep2->Title = 'Form step 2';
        $formStep2->write();
        $formStep2->publishRecursive();

        $textField3 = new EditableTextField();
        $textField3->Name = 'text-field-3';
        $textField3->Title = 'Text field 3';
        $textField3->write();
        $textField3->publishRecursive();

        $userDefinedForm->Fields()->add($formStep1);
        $userDefinedForm->Fields()->add($textField2);
        $userDefinedForm->Fields()->add($formStep2);
        $userDefinedForm->Fields()->add($textField3);

        $userFormWidget->write();

        $form = $userFormWidgetController->UserDefinedForm();

        $this->assertNotNull($form);
        $this->assertEquals(Form::class, get_class($form));
        $fields = $form->Fields();
        $this->assertEquals(5, $fields->count());
    }

    public function testGetCMSFields()
    {
        $userFormWidget = new UserFormWidget();
        $fields = $userFormWidget->getCMSFields();

        $this->assertNotNull($fields);
    }

    public function testGetControllerName()
    {
        $userFormWidget = new UserFormWidget();
        $this->assertEquals(UserFormWidgetController::class, $userFormWidget->getControllerName());
    }
}
