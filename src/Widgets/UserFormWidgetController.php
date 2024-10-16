<?php


namespace Logicbrush\UserFormsUtils\Widgets;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\UserForms\Form\UserForm;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableFormStep;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\Widgets\Model\WidgetController;

if ( ! class_exists( WidgetController::class ) ) {
	return;
}


class UserFormWidgetController extends WidgetController
{

	/**
	 *
	 * @Metrics( crap = 2 )
	 * @return unknown
	 */


	public function Showing() {
		return ( $userDefinedForm = $this->UserForm() ) && $userDefinedForm->ID != Controller::curr()->ID;
	}


	/**
	 *
	 * @Metrics( crap = 3 )
	 * @return unknown
	 */
	public function FormContent() {
		if ( $this->UserForm()->exists() && $this->UserForm()->Content ) {
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


	/**
	 *
	 * @Metrics( crap = 6.19 )
	 * @return unknown
	 */
	public function UserDefinedForm() {
		$userDefinedForm = $this->UserForm();

		if ( ! $userDefinedForm || ! $userDefinedForm->exists() ) {
			return null;
		}

		$fields = FieldList::create();
		$required = RequiredFields::create();

		$userDefinedFormFields = EditableFormField::get()->filter( ['ParentID' => $userDefinedForm->ID] );

		$this->setupFields( $userDefinedFormFields, $fields, $required );

		$actions = FieldList::create();
		$actions->push(
			FormAction::create(
				'process',
				$userDefinedForm->SubmitButtonText ?: _t( 'UserDefinedForm.SUBMITBUTTON', 'Submit' )
			)
		);

		$form = Form::create( $this, UserDefinedForm::class, $fields, $actions, $required );
		$form->setFormAction( $this->UserForm()->Link( 'Form' ) . '?BackURL=' . urlencode( $this->UserForm()->Link() . '#Form_Form' ) );

		$data = $this->getRequest()->getSession()->get( "FormInfo.UserForm_Form_{$userDefinedForm->ID}.data" );
		if ( is_array( $data ) ) {

			// Load form data.
			$form->loadDataFrom( $data );

			$result = $this->getRequest()->getSession()->get( "FormInfo.UserForm_Form_{$userDefinedForm->ID}.result" );
			if ( isset( $result ) ) {

				// Load form validation results.
				$form->loadMessagesFrom( unserialize( $result ) );

			}
		}

		return $form;
	}




	/**
	 *
	 * @Metrics( crap = 4 )
	 */
	private function setupFields( DataList $userDefinedFormFields, FieldList $fields, RequiredFields $required ) {
		$formStepsCount = $userDefinedFormFields->filter( ['ClassName' => EditableFormStep::class] )->Count();

		foreach ( $userDefinedFormFields as $field ) {
			if ( $field instanceof EditableFormStep ) {
				$this->processFormStepFields( $field, $fields, $formStepsCount );

				continue;
			}

			$fields->push( $formField = $field->getFormField() );

			if ( $field->Required ) {
				$required->addRequiredField( $formField->Name );
				$formField->addExtraClass( 'requiredField' );
			}
		}
	}




	/**
	 *
	 * @Metrics( crap = 3 )
	 */
	private function processFormStepFields( EditableFormStep $field, FieldList $fields, int $formStepsCount ) {
		if ( $formStepsCount < 2 ) {
			return;
		}

		$stepField = $field->getFormField();

		if ( $stepField->title ) {
			$headerField = HeaderField::create(
				$stepField->name,
				$stepField->title,
				3
			);
			$fields->push( $headerField );
		}
	}


}
