<?php


namespace Logicbrush\UserFormsUtils\FormFields;

use Logicbrush\UserFormsUtils\FormFields\Submission\ImageSubmittedFormField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\Submission\SubmittedFormField;

class EditableSignatureField extends EditableFormField {

	private static $singular_name = 'Signature Field';
	private static $plural_name = 'Signature Fields';
	private static $table_name = 'EditableSignatureField';

	/**
	 *
	 * @return unknown
	 */


	public function getFormField() {
		$field = TextField::create( $this->Name, $this->Title ?: false )
		->setFieldHolderTemplate( EditableFormField::class . '_holder' )
		->setTemplate( EditableSignatureField::class )
		;
		$this->doUpdateFormField( $field );
		return $field;
	}


	/**
	 * Returns an image field, so the signature can be viewed in the CMS and in
	 * reports.
	 *
	 * @return unknown
	 */
	public function getSubmittedFormField() : SubmittedFormField
	{
		return ImageSubmittedFormField::create();
	}


}
