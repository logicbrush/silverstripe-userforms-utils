<?php


namespace Logicbrush\UserFormsUtils\FormFields\Submission;

use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\UserForms\Model\Submission\SubmittedFormField;

class ImageSubmittedFormField extends SubmittedFormField {

	/**
	 *
	 * @return unknown
	 */


	public function getFormattedValue() {
		if ( $this->Value ) {
			return DBField::create_field( 'HTMLText', sprintf(
					'<img src="data:%s" />',
					htmlspecialchars( $this->Value, ENT_QUOTES )
				) );
		}
		return false;
	}


}
