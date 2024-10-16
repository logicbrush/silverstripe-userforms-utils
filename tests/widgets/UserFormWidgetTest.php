<?php


namespace Logicbrush\UserFormsUtils\Tests\Widgets;

use Logicbrush\UserFormsUtils\Widgets\UserFormWidget;
use Logicbrush\UserFormsUtils\Widgets\UserFormWidgetController;
use SilverStripe\Control\Session;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\Form;
use SilverStripe\UserForms\Model\EditableFormField\EditableFormStep;
use SilverStripe\UserForms\Model\EditableFormField\EditableTextField;
use SilverStripe\UserForms\Model\UserDefinedForm;

class UserFormWidgetTest extends FunctionalTest
{
	protected $usesDatabase = true;

	/**
	 *
	 */
	public function testCreateUserFormWidget() {
		$userFormWidget = new UserFormWidget();
		$userFormWidget->write();

		$this->assertNotNull($userFormWidget);
	}


	/**
	 *
	 */
	public function testShowing() {
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


	/**
	 *
	 */
	public function testFormContent() {
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

		$this->assertStringContainsString('<p>User Defined Form</p>', $formContent);
	}


	/**
	 *
	 */
	public function testUserDefinedForm() {
		$userDefinedForm = new UserDefinedForm();
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
		$userFormWidgetController->getRequest()->setSession(new Session([]));

		$this->assertNull($userFormWidgetController->UserDefinedForm());

		$userFormWidget->UserFormID = $userDefinedForm->ID;
		$userFormWidget->write();

		$form = $userFormWidgetController->UserDefinedForm();

		$this->assertNotNull($form);
		$this->assertEquals(Form::class, get_class($form));
		$this->assertEquals(1, $form->Fields()->count());
	}


	/**
	 *
	 */
	public function testUserDefinedFormSteps() {
		$userDefinedForm = new UserDefinedForm();
		$userDefinedForm->write();
		$userDefinedForm->publishRecursive();

		$formStep1 = new EditableFormStep();
		$formStep1->Name = 'form-step-1';
		$formStep1->Title = 'Form step 1';
		$formStep1->write();
		$formStep1->publishRecursive();

		$textField1 = new EditableTextField();
		$textField1->Name = 'text-field-1';
		$textField1->Title = 'Text field 1';
		$textField1->Required = true;
		$textField1->write();
		$textField1->publishRecursive();

		$userDefinedForm->Fields()->add($formStep1);
		$userDefinedForm->Fields()->add($textField1);

		$userFormWidget = new UserFormWidget();
		$userFormWidget->UserFormID = $userDefinedForm->ID;
		$userFormWidget->write();

		$userFormWidgetController = new UserFormWidgetController($userFormWidget);
		$userFormWidgetController->getRequest()->setSession(new Session([
					"FormInfo.UserForm_Form_{$userDefinedForm->ID}.data" => [],
				]));
		$form = $userFormWidgetController->UserDefinedForm();

		$fields = $form->Fields();
		$this->assertEquals(1, $fields->count());

		$formStep2 = new EditableFormStep();
		$formStep2->Name = 'form-step-2';
		$formStep2->Title = 'Form step 2';
		$formStep2->write();
		$formStep2->publishRecursive();

		$textField2 = new EditableTextField();
		$textField2->Name = 'text-field-2';
		$textField2->Title = 'Text field 2';
		$textField2->write();
		$textField2->publishRecursive();

		$userDefinedForm->Fields()->add($formStep2);
		$userDefinedForm->Fields()->add($textField2);

		$userFormWidget->write();

		$form = $userFormWidgetController->UserDefinedForm();

		$fields = $form->Fields();
		$this->assertEquals(4, $fields->count());
	}


	/**
	 *
	 */
	public function testGetCMSFields() {
		$userFormWidget = new UserFormWidget();
		$fields = $userFormWidget->getCMSFields();

		$this->assertNotNull($fields);
	}


}
