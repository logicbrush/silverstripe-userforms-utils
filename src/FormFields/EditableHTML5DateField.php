<?php


namespace Logicbrush\UserFormsUtils\FormFields;

use Logicbrush\UserFormsUtils\FormFields\Impl\HTML5DateField;
use SilverStripe\Forms\DateField;
use SilverStripe\UserForms\Model\EditableFormField;

/**
 * An HTML5 date field.
 *
 */


class EditableHTML5DateField extends EditableFormField {

	private static $singular_name = 'HTML5 Date Field';
	private static $plural_name = 'HTML5 Date Fields';
	private static $table_name = 'EditableHTML5DateField';

	/**
	 *
	 * @Metrics( crap = 6, uncovered = true )
	 * @return unknown
	 */
	public function getFormField() {
		$field = HTML5DateField::create( $this->Name, $this->Title ?: false )
		->setFieldHolderTemplate( EditableFormField::class . '_holder' )
		;
		$this->doUpdateFormField( $field );
		return $field;
	}


}
