<?php


namespace Logicbrush\UserFormsUtils\FormFields\Impl;

use SilverStripe\Forms\DateField;

class HTML5DateField extends DateField {

	/**
	 *
	 * @param unknown $name
	 * @param unknown $title (optional)
	 * @param unknown $value (optional)
	 */


	public function __construct( $name, $title = null, $value = "" ) {
		parent::__construct( $name, $title, $value );
		$this->setHTML5( true );
	}


	/**
	 *
	 * @return unknown
	 */
	public function getAttributes() {
		return array_merge(
			parent::getAttributes(),
			['type' => 'date']
		);
	}


}
